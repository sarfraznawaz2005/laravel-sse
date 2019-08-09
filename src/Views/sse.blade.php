@if(session()->has('noty.messages'))
    <script type="text/javascript">
        (function () {
            @foreach (session('noty.messages') as $item)
            new Noty({
                text: '{{$item['text']}}',
                type: '{{$item['type']}}',
                theme: '{{$item['options']['theme']}}',
                layout: '{{$item['options']['layout']}}',
                timeout: '{{$item['options']['timeout']}}',
                progressBar: '{{$item['options']['progressBar']}}',
                closeWith: [{!! extractQuoted($item['options']['closeWith']) !!}],
                animation: {
                    open: '{{$item['options']['animation']['open']}}',
                    close: '{{$item['options']['animation']['close']}}'
                },
                sounds: {
                    sources: [{!! extractQuoted($item['options']['sounds']['sources']) !!}],
                    volume: '{{$item['options']['sounds']['volume']}}',
                    conditions: [{!! extractQuoted($item['options']['sounds']['conditions']) !!}]
                },
                docTitle: {
                    conditions: [{!! extractQuoted($item['options']['docTitle']['conditions']) !!}]
                },
                modal: '{{$item['options']['modal']}}',
                force: '{{$item['options']['force']}}',
                queue: '{{$item['options']['queue']}}',
                maxVisible: '{{$item['options']['maxVisible']}}',
                killer: '{{$item['options']['killer']}}',
                container: '{{$item['options']['container'] ?: ''}}',
                id: '{{$item['options']['id'] ?: ''}}'
            }).show();
            @endforeach
        })();
    </script>
@endif
