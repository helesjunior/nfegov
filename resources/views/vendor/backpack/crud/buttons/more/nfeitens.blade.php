{{-- @if (!$crud->model->translationEnabled()) --}}
{{-- Single edit button --}}
<div class="btn-group">
    <button type="button"
            class="btn btn-xs dropdown-toggle dropdown-toggle-split"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            title="Mais"
    >
        <i class="la la-cog"></i>
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>

    <ul class="dropdown-menu dropdown-menu-right">
        <li>
            &nbsp; <a href="/nfe/{{ $entry->getKey() }}/itens">
                <i class="la la-greater-than"></i> Itens
            </a>
        </li>
    </ul>
</div>
