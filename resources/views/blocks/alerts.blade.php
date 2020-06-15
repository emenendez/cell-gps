@if (session('success')
     || session('danger')
     || session('error')
     || session('status')
     || session('info')
     || (isset($errors) && count($errors) > 0))

    <div class="container">
        <div class="row mt-2 mb-2">
            <div class="col">
            @if (session('success'))
                <div class="alert alert-success">
                    {!! session('success') !!}
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-success">
                    {!! session('status') !!}
                </div>
            @endif
            @if (session('danger'))
                <div class="alert alert-danger">
                    {!! session('danger') !!}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {!! session('error') !!}
                </div>
            @endif
            @if (session('info'))
                <div class="alert alert-info">
                    {!! session('info') !!}
                </div>
            @endif
            @if (isset($errors) && count($errors) > 0)
                <div class="alert alert-danger">
                    <ul class="fa-ul">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </div>
        </div>
    </div>
@endif
