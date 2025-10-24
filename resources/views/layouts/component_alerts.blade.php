@if(session()->has('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    {!! session()->get('success') !!}
</div>
@endif

@if(session()->has('info'))
<div class="alert alert-info alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    {!! session()->get('info') !!}
</div>
@endif

@if(session()->has('warning'))
<div class="alert alert-warning alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    {!! session()->get('warning') !!}
</div>
@endif

@if(session()->has('failed'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    {!! session()->get('failed') !!}
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    {!! session()->get('error') !!}
</div>
@endif
