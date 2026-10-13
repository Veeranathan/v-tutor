
<?phpnamespace App\Http\Controllers;

use App\Models\ZohoToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ZohoAuthController extends Controller
{
    public function redirect()
    {
        $state = Str::random(32);
        session(['zoho_oauth_state' => $state]);

        $scopes = implode(',', [
            'Desk.basic.READ',
            'Desk.tickets.READ',
            'Desk.tickets.CREATE',
            'Desk.contacts.READ',
            'Desk.contacts.CREATE',
        ]);

        $url = config('services.zoho.accounts_base').'/oauth/v2/auth?'.http_build_query([
            'scope' => $scopes,
            'client_id' => config('services.zoho.client_id'),
            'response_type' => 'code',
            'access_type' => 'offline',   // gives refresh_token
            'redirect_uri' => config('services.zoho.redirect_uri'),
            'prompt' => 'consent',
            'state' => $state,
        ]);

        return redirect()->away($url);
    }

    public function callback(Request $request)
    {
        if (!$request->has('code') || $request->state !== session('zoho_oauth_state')) {
            abort(403, 'Invalid state or missing code.');
        }

        $resp = Http::asForm()->post(config('services.zoho.accounts_base').'/oauth/v2/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.zoho.client_id'),
            'client_secret' => config('services.zoho.client_secret'),
            'redirect_uri' => config('services.zoho.redirect_uri'),
            'code' => $request->code,
        ])->throw()->json();

        ZohoToken::query()->delete(); // store single record
        ZohoToken::create([
            'access_token' => $resp['access_token'],
            'refresh_token' => $resp['refresh_token'] ?? null,
            'expires_at' => now()->addSeconds(($resp['expires_in'] ?? 3600) - 60),
        ]);

        return response('Zoho connected successfully!');
    }
}
