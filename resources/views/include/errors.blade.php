@if(Session::has('success'))
    <div class="alert alert-success" id="cross" >
     
        <strong>
            {!!Session::get('success')!!}
        </strong>
         <a href="#" class="close" data-dismiss="alert" style="float: right !important ;" onclick="del()">&times;</a>
    </div>
@endif
@if(Session::has('error'))
    <div class="alert alert-danger" id="cross" >
     
        <strong>
            {{Session::get('error')}}
        </strong>
         <a href="#" class="close" data-dismiss="alert" style="float: right !important ;" onclick="del()">&times;</a>
    </div>
@endif
@if ($errors->any())
{{-- @dd($errors->all()) --}}
    {{-- <div class="alert alert-danger alert-dismissible" style="text-align: center;" > --}}
    <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" style="float: left !important ;">&times;</a>
        <ul>
            @foreach ($errors->all() as $error)
                <li style="list-style: none;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    function del()
    {
        $('#cross').hide();
    }
    
</script>
