<?php

namespace App\Http\Controllers\UserFavouriteWishlist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserFavouriteWishlistController extends Controller
{
    public function saveUserTofavourite(Request $request){
        // try{
        //     if(@Auth::check()){
        //         $favourite_user_id = $request->data['favourite_user_id'];
        //         $isFav = UserToFavourite::where(['favourite_user_id'=>$request->data['favourite_user_id'],'user_id'=>@Auth::user()->id])->first();
        //         if(@$isFav){
        //             UserToFavourite::where(['favourite_user_id'=>$request->data['favourite_user_id'],'user_id'=>@Auth::user()->id])->delete();
        //             $response['result']['status'] = 'Removed';
        //             $response['result']['message'] = 'Removed from your Wishlist';
        //         }else{
        //             $addUserToFav['favourite_user_id'] =$request->data['favourite_user_id']; 
        //             $addUserToFav['user_id'] = @Auth::user()->id; 
        //             $fav = UserToFavourite::create($addUserToFav);
        //             $response['result']['status'] = 'Added';
        //             $response['result']['message'] = 'Added to your Wishlist';
        //         }
        //     }else{
        //         $response['result']['status'] = '2';
        //         $response['result']['message'] = 'Please login!';
        //     }
        //     return response()->json($response,200);
        // }catch(\Exception $e){
        //     \Log::error($e->getMessage());
        //     $data['status'] = 0;
        //     $data['message'] = $e->getMessage();
        //     return response()->json($data,200);
        // }
    }
}
