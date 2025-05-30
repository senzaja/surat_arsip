@extends('layouts.main')

@push('script')
    <script>
        $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            $('#editModal form').attr('action', "{{ route('reference.classification.index') }}/" + id);
            $('#editModal input:hidden#id').val(id);
            $('#editModal input#code').val($(this).data('code'));
            $('#editModal input#type').val($(this).data('type'));
            $('#editModal input#description').val($(this).data('description'));
        });

        // Optional: Confirmation for delete action
        $(document).on('click', '.btn-delete', function () {
            if (!confirm("{{ __('menu.general.confirm_delete') }}")) {
                return false;
            }
            $(this).closest('form').submit();
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="[__('menu.reference.menu'), __('menu.reference.classification')]">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            {{ __('menu.general.create') }}
        </button>
    </x-breadcrumb>

    <div class="card mb-5">
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-light">
                    <tr>
                        <th>{{ __('model.classification.code') }}</th>
                        <th>{{ __('model.classification.type') }}</th>
                        <th>{{ __('model.classification.description') }}</th>
                        <th>{{ __('menu.general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $classification)
                        <tr>
                            <td>{{ $classification->code }}</td>
                            <td>{{ $classification->type }}</td>
                            <td>{{ $classification->description }}</td>
                            <td>
                                <button class="btn btn-info btn-sm btn-edit"
                                        data-id="{{ $classification->id }}"
                                        data-code="{{ $classification->code }}"
                                        data-type="{{ $classification->type }}"
                                        data-description="{{ $classification->description }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                    {{ __('menu.general.edit') }}
                                </button>

                                <form action="{{ route('reference.classification.destroy', $classification) }}" class="d-inline" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                                        {{ __('menu.general.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">{{ __('menu.general.empty') }}</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th>{{ __('model.classification.code') }}</th>
                        <th>{{ __('model.classification.type') }}</th>
                        <th>{{ __('model.classification.description') }}</th>
                        <th>{{ __('menu.general.action') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {!! $data->appends(['search' => $search])->links() !!}

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('reference.classification.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('menu.general.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-input-form name="code" :label="__('model.classification.code')" />
                    <x-input-form name="type" :label="__('model.classification.type')" />
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        {{ __('menu.general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary">{{ __('menu.general.save') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('menu.general.edit') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <x-input-form name="code" :label="__('model.classification.code')" />
                    <x-input-form name="type" :label="__('model.classification.type')" />
                    <x-input-form name="description" :label="__('model.classification.description')" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        {{ __('menu.general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary">{{ __('menu.general.update') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
