<tr class="parent-row"
    style="
    @switch($level)
        @case(0) background: #E8EDFA; border-left: 5px solid #2A4B6B;  @break
        @case(1) background: #E8F5F0; border-left: 3px solid #1A5548;  @break
        @case(2) background: #FAEEE8; border-left: 1px solid #7A4F3D;@break
    @endswitch
">
    <td>
        {{ $category->name }}
    </td>
    <td>
        <span class="status-badge {{ $category->status === 'active' ? 'sb-active' : 'sb-inactive' }}">
            {{ ucfirst($category->status) }}
        </span>
    </td>
    <td>
        {{ $category->created_at ? $category->created_at->format('d/m/y') : 'N/A' }}
    </td>
    <td>
        <div class="d-flex">
            <a href="{{ route('admin.edit_category', $category->id) }}" class="btn btn-sm btn-primary me-2">Edit</a>
            <form action="{{ route('admin.delete_category', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Delete</button>
            </form>
        </div>
    </td>
</tr>
@if ($level < 3)
    @if ($category->childrens->count() > 0)
        @foreach ($category->childrens as $child)
            @include('admin.pages.category_row', ['category' => $child, 'level' => $level + 1])
        @endforeach
    @endif
@endif
