@extends('layouts.app', ['breadcrumb' => [
trans('breadcrumb.home') => route('home'),
trans('breadcrumb.users') => route('user.index')
]])

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <a href="{{route('user.create')}}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i>&nbsp;{{__('pages/user.buttons.create')}}
            </a>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#searchModal">
                <i class="fas fa-search"></i>&nbsp;{{__('pages/user.buttons.search')}}
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table dt-responsive nowrap dataTable no-footer" id="users-datatable">
                    <thead>
                        <tr>
                            <th class="ColOffusq">{{__('pages/user.list.firstname')}}</th>
                            <th class="ColOffusq">{{__('pages/user.list.lastname')}}</th>
                            <th class="ColOffusq">{{__('pages/user.list.email')}}</th>
                            <th>{{__('pages/user.list.roles')}}</th>
                            <th>{{ __('lists.createdby') }}</th>
                            <th>{{ __('lists.updatedby' )}}</th>
                        </tr>
                    </thead>
                    <tbody id="tablecontents">
                    @foreach ($users as $user)
                        <tr class="row1" data-id="{{ $user->id }}">
                            <td>@if(!is_null($user->first_name))
                                    {{ $user->first_name }}
                                @else
                                    <i class="fas fa-ban text-primary"></i>
                                @endif</td>
                            <td>@if(!is_null($user->last_name))
                                    {{ $user->last_name }}
                                @else
                                    <i class="fas fa-ban text-primary"></i>
                                @endif</td>
                            <td>{{ $user->email }}</td>
                            <td>@if($user->roles->count() > 1)
                                    @foreach ($user->roles->pluck('name')->toArray() as $value)
                                        {{ $loop->first ? '' : ', ' }}{{ trans('labels.roles.'.$value) }}
                                    @endforeach
                                @else
                                    {{ trans('labels.roles.'.$user->roles->pluck('name')->toArray()[0]) }}
                                @endif
                            </td>
                            <td>
                                @if($user->created_by)
                                    {{ $user->created_by->fullName }}<br><span class="badge colorbadges timetolocalezone">{{ $user->created_at }}</span>
                                @else
                                    <i class="fas fa-user-slash text-primary "></i>
                                @endif
                            </td>
                            <td>
                                @if($user->updated_by)
                                    {{ $user->updated_by->fullName }}<br><span class="badge colorbadges timetolocalezone">{{ $user->updated_at }}</span>
                                @else
                                    <i class="fas fa-user-slash text-primary "></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{__('pages/user.buttons.search')}}</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="searchInput" placeholder="Nom, Prénom ou Email" class="form-control" />
                        </div>
                        <div class="table-responsive">
                        <table class="table dt-responsive nowrap dataTable no-footer" id="users-datatable">
                            <thead>
                                <tr>
                                    <th class="ColOffusq">{{__('pages/user.list.firstname')}}</th>
                                    <th class="ColOffusq">{{__('pages/user.list.lastname')}}</th>
                                    <th class="ColOffusq">{{__('pages/user.list.email')}}</th>
                                </tr>
                            </thead>
                            <tbody id="searchContent"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('buttons.cancel')}}</button>
            </div>
        </div>
    </div>
</div>


@endsection

@push('page_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    let userEditUrl = "{{ route('user.edit', ['user' => 'ID']) }}";
    let userSearchUrl = "{{ route('users.search', ['searchTerm' => 'SEARCH'])}}";
    $(function() {
        $("#tablecontents").on('click', 'tr', function() {
            var id = $(this).attr('data-id');
            document.location = userEditUrl.replace('ID', id);
        });

        $('#searchModal').on('shown.bs.modal', function () {
            $('#searchInput').focus()
        });

        $('#searchInput').on('keyup', function() {
            let searchTxt = $(this).val();
            if(searchTxt.length >= 3) {
                searchAddTextRow("{{__('pages/user.labels.searchinprogress')}}");
                $.getJSON({
                    url: userSearchUrl.replace('SEARCH', searchTxt),
                    success: function(data) {
                        if(data.length == 0) {
                            searchAddTextRow("{{__('pages/user.labels.searchnoresult')}}");
                        } else {
                            $('#searchContent').empty();
                            $(data).each(function(idx, row) {
                                searchAdduserRow(row);
                            });
                            $("#searchContent").on('click', 'tr', function() {
                                var id = $(this).attr('data-id');
                                document.location = userEditUrl.replace('ID', id);
                            });
                        }
                    }
                })
            } else {
            searchAddTextRow("{{__('pages/user.labels.searchnoresult')}}");
            }
        });
    });

    function searchAddTextRow(text) {
        let searchContent = $('#searchContent');
        searchContent.empty();
        let td = $('<td />', {text: text});
        td.attr('colspan', 4).css('text-align', 'center');
        searchContent.append( $('<tr />').append(td) );
    }

    function searchAdduserRow(row) {
        let searchContent = $('#searchContent');
        let tr = $('<tr />', {class:'row1', 'data-id': row.id});
        tr.append($('<td />', {text: row.first_name}));
        tr.append($('<td />', {text: row.last_name}));
        tr.append($('<td />', {text: row.email}));
        searchContent.append(tr);
    }
</script>
@endpush
