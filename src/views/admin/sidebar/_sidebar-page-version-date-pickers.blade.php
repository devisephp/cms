@php $selectedVersion = $pageVersions[0] @endphp

@foreach ($pageVersions as $pageVersion)
    @if ($pageVersion->selected)
        @php $selectedVersion = $pageVersion @endphp
    @endif
@endforeach

<div class="js-datepickers hidden">
    <span>Show live<span>
    <input type="text" name="starts_at" value="<?= $selectedVersion->starts_at_human ?>" placeholder="Start Date" class="js-datepicker js-start-date" style="line-height: 20px;">
    <span>thru</span>
    <input type="text" name="ends_at" value="<?= $selectedVersion->ends_at_human ?>" placeholder="End Date" class="js-datepicker js-end-date" style="line-height: 20px;">
    <button data-url="<?= URL::route('dvs-update-page-versions-dates', $selectedVersion->id) ?>" class="js-update-dates btn">Update</button>
</div>