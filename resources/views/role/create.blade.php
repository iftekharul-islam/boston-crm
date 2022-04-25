@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-4 col-md-offset-6 m-auto">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="exampleInputEmail1">Role Name</label>
                    <input type="text" class="form-control" name="name" id="role" aria-describedby="roleHelp"
                           placeholder="Enter role name" value="{{ old('name') }}">
                    @if($errors->has('name'))
                        <div class="error text-danger">{{ $errors->first('name') }}</div>
                    @else
                        <small id="roleHelp" class="form-text text-muted">Please avoid duplicate role name.</small>
                    @endif
                </div>
                @foreach($permissions ?? [] as $permission)
                    <div class="mt-3">
                        <label for="{{ $permission }}" class="fs-3 fw-bold text-uppercase">{{ $permission }}</label>
                        <div class="d-flex">
                            @foreach(['view', 'create', 'update', 'delete'] as $permission_name)
                                <div class="form-group form-check">
                                    <input type="checkbox" name="permissions[]"
                                           data-name="{{ $permission_name . '.' . $permission }}"
                                           data-model-name="{{ $permission }}"
                                           class="form-check-input check-data" value="{{ $permission_name . '.' . $permission }}"
                                           id="permission-{{ $permission_name. '-' . $permission }}">
                                    <label class="form-check-label me-3 fs-5 text-uppercase" for="exampleCheck1">{{ $permission_name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section("scripts")
    <script>
        $(document).on("click", ".check-data", function () {
            let all_siblings = $(".check-data");
            let self = $(this);
            let name = self.data('name');
            let model_name = self.data('model-name');
            let view_select;
            if (name.includes('.' + model_name)) {
                view_select = checkView(name, self);
                if (view_select) {
                    enableCheck(all_siblings, "view." + model_name);
                }
            }
        });

        /**
         * Check if data select on view.
         *
         * @param name
         * @param self
         * @returns {boolean}
         */
        function checkView(name, self) {
            if (name.includes('view')) {
                $(self).prop('checked', $(self).is(":checked"));

                return false;
            }

            return true;
        }

        /**
         * Select view auto if select
         * create, update, delete.
         *
         * @param all_siblings
         * @param viewName
         */
        function enableCheck(all_siblings, viewName) {
            all_siblings.each((ele) => {
                let item = all_siblings[ele];
                let name = $(item).data('name');
                if (name === viewName) {
                    $(item).prop('checked', true);
                }
            });
        }
    </script>
@endsection
