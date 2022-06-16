<div class="text-left d-flex justify-content-between align-items-center">
        {{--Update Button--}}
        <a href="{{ route('edit', $reference->id) }}" title="@lang('locale.Edit Reference')" class="action-btn me-50 text-warning">
            <div class="d-flex justify-content-center align-items-center bg-primary" style="width: 34px; height: 34px;"><img src="{{ asset('images/svg/pencil_w.svg') }}" width="16"></div>
        </a>

    {{--Delete Button--}}
        <a href="#" title="@lang('locale.Delete Reference')" class="action-btn text-danger del-btn">
            <div class="d-flex justify-content-center align-items-center" style="width: 34px; height: 34px; background-color: #C93334;"><img src="{{ asset('images/svg/trash_w.svg') }}" width="16"></div>
        </a>
        <form action="{{ route('destroy', $reference->id) }}" method="post" class="delete-btn-form d-inline">
            @method('DELETE')
            @csrf
        </form>
</div>
