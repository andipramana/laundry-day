@if ($row->status == 'Registered')
    primary
@elseif ($row->status == 'Washed')
    warning
@elseif ($row->status == 'Dried')
    info
@else
    success
@endif
