{{-- components/basic-table.blade.php --}}
<div class="panel-body widget-shadow">
    <h4>{{ $title ?? 'Basic Table' }}</h4>
    <table class="table">
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
                <tr>
                    @foreach($row as $key => $cell)
                        @if(isset($rawColumns) && in_array($key, $rawColumns))
                            <td>{!! $cell !!}</td>
                        @else
                            <td>{{ $cell }}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
