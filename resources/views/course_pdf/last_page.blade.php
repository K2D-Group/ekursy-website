<?php
    $naglowki = [
            'date' => 'Aktualizacje',
            'author' => 'Autor',
            'reviewer' => 'Skład',
            'source' => 'Źródła'
    ];
?>
<h1>Informacje dodatkowe</h1>
<columns column-count="2" vAlign="" />
<ul>
    @foreach($info as $section_name => $section)
        <li style="font-size: 4mm;margin:0;padding:0">
            <span>{{$section_name}}</span>
            <ul>
                @foreach($section as $page_name => $page)
                    <li style="font-size: 3mm;margin:0;padding:0">
                        <span>{{$page_name}}</span>
                        <ul>
                            @foreach(['date', 'author', 'reviewer', 'source'] as $meta)
                                @if(isset($page[$meta]))
                                    <li style="font-size: 2mm">
                                        <span style="color: #909090">{{ $naglowki[$meta] }}:</span>
                                        @if($meta == 'source')
                                            {{ implode(', ', array_keys($page[$meta])) }}
                                        @else
                                            {{ implode(', ', $page[$meta]) }}
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>
{{--<columnbreak />--}}
<columns column-count="1"  />