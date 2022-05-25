<script>
    let toastrInfo = [];
    let toastrSuccess = [];
    let toastrError = [];

    @if($message = Session::get('info'))
    toastrInfo.push("{{$message}}");
    @endif
    @if($message = Session::get('success'))
    toastrSuccess.push("{{$message}}");
    @endif
    @if($message = Session::get('error'))
    toastrError.push("{{$message}}");
    @endif
    @if(isset($errors))
    @foreach ($errors->all() as $error)
    toastrError.push("{{$error}}");
    @endforeach
    @endif
</script>
