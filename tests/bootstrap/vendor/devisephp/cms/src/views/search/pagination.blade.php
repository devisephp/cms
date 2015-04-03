@php
    $currentPage = Input::get('page');
@endphp

@if($totalPageCount > 1)
    <ul class="pagination search-results">
        <li class="<?= ($currentPage != 1 && $currentPage > 0) ?: 'disabled' ?>">
            <span><a href="<?= URL::current() ?>?page=<?=$currentPage - 1?><?= $appends ?>">&laquo;</a></span>
        </li>

        @for ($i = 1; $i <= $totalPageCount; $i++)
            @if ($i == $page)
                <li class="active"><span><?= $i ?></span></li>
            @else
                <li class="paginated page item">
                    <a href="<?= URL::current() ?>?page=<?=$i?><?= $appends ?>"><?= $i ?></a>
                </li>
            @endif
        @endfor

        <li class="<?= ($currentPage < $totalPageCount && $currentPage > 0) ?: 'disabled' ?>">
            <span><a href="<?= URL::current() ?>?page=<?=$currentPage + 1?><?= $appends ?>">&raquo;</a></span>
        </li>
    </ul>
@endif