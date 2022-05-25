@if ($action == 'create')
    @php
        $breadcrumbLabel = trans('breadcrumb.create');
        $breadcrumbAction = route('user.create');
        $formTitle = trans('pages/user.titles.creating');
        $formAction = route('user.store');
    @endphp
@else
    @php
        $breadcrumbLabel = trans('breadcrumb.update');
        $breadcrumbAction = route('user.edit', ['user' => $user->id]);
        $formTitle = trans('pages/user.titles.updating');
        $formAction = route('user.update', ['user' => $user->id]);
    @endphp
@endif


@extends('layouts.app', ['breadcrumb' => [
trans('breadcrumb.home') => route('home'),
trans('breadcrumb.users') => route('user.index'),
$breadcrumbLabel => $breadcrumbAction
]])

@section('backButton')
    @role('admin')
    <a href="{{ route('user.index') }}" class='text-secondary'>
        <i class="fas fa-backspace"></i>&nbsp;
        {{ __('buttons.backtolist') }}
    </a>
    @endrole
@endsection

@section('content')
    <div class="container-fluid">
        @role('admin')
        <h5 class="text-primary pageTitle">
            {{ $formTitle }}
        </h5>
        @endrole
        @role('user')
        <h5 class="text-primary pageTitle">
            Mise à jour du profil
        </h5>
        @endrole
        <form action="{{ $formAction }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-6">
                            <label>{{ __('pages/user.labels.firstname') }}</label>
                            <input type="text" name="first_name" class="form-control"
                                value="{{ $user->first_name ?? old('first_name') }}"/>
                        </div>
                        <div class="form-group col-6">
                            <label>{{ __('pages/user.labels.lastname') }}</label>
                            <input type="text" name="last_name" class="form-control"
                                value="{{ $user->last_name ?? old('last_name') }}"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label>{{ __('pages/user.labels.email') }}</label>
                            <input type="text" name="email" class="form-control"
                                value="{{ $user->email ?? old('email') }}" required/>
                        </div>
                    </div>
                    @role('admin')
                    <div class="row">
                        <div class="form-group col-12">
                            <label>{{ __('pages/user.labels.roles') }}</label>
                            <select name="roles[]" class="form-control" multiple="multiple" size="1" style="visibility: hidden">
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}"
                                        @if (($action == 'update' && $user->hasRole($role))
                                        || (old('roles') && in_array($role, old('roles'))))
                                            selected
                                        @endif
                                    >{{ trans('labels.roles.' . $role) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endrole
                </div>
                <div class="card-footer" id="card_footer">
                    <button type="submit" id="saveButton" style="display:none;" class="btn btn-success">
                        {{ __('buttons.save') }} </button>
                    <div class="btn-group dropright">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-save"></i>&nbsp;{{ __('buttons.save') }}
                        </button>
                        <div class="dropdown-menu">
                            <!-- Dropdown menu links -->
                            <button class="dropdown-item" onclick="newform()" name="newform"><i class="fas fa-plus-circle"></i>&nbsp;{{ __('pages/user.buttons.newform') }}</button>
                            <button class="dropdown-item" onclick="backtolist()" name="backtolist"><i class="fas fa-users"></i>&nbsp;{{ __('pages/user.buttons.backtolist') }}</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
@push('page_scripts')

    <script>
        function newform() {
            $('#saveButton').click();
        }

        function backtolist() {
            $('#saveButton').click();
        }

        $('#btnChangePwd').on('click', function(e) {
            e.preventDefault();
            $('#changePwdUserId').val($(this).attr('data-userid'));
            $('#modalChangePwd').modal('show');
        });
    </script>
@endpush
