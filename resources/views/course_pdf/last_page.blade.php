<?php
    $naglowki = [
            'date' => 'Aktualizacje',
            'author' => 'Autor',
            'reviewer' => 'Skład',
            'source' => 'Źródła'
    ];
?>
<h1>Informacje dodatkowe</h1>
<columns column-count="2" vAlign="J" />
@foreach($info as $section_name => $section)
    <div style="font-size: 5mm;margin-left: 5mm">
        <span>{{$section_name}}</span>
        @foreach($section as $page_name => $page)
            <div style="font-size: 4mm;margin-left: 5mm">
                <span>{{$page_name}}</span>
                @foreach(['date', 'author', 'reviewer', 'source'] as $meta)
                    @if(isset($page[$meta]))
                        <div style="font-size: 3mm;margin-left: 5mm">
                            <span style="color: #909090">{{ $naglowki[$meta] }}:</span>
                            @if($meta == 'source')
                                {{ implode(', ', array_keys($page[$meta])) }}
                            @else
                                {{ implode(', ', $page[$meta]) }}
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
@endforeach
<columns column-count="1"  />