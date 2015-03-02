<div style="text-align: center; padding-top: 50%">
    <p style="font-size: 15mm">{{ $course->name }}</p>
    <p style="font-size: 5mm;  padding-top: 20mm">{{ $course->version }}</p>
</div>
<div style="position: absolute; bottom: 8mm; left: 8mm; right: 8mm; text-align: center; font-size: 3mm;">
    <small>
        {{ Config::get('app.copyright.year') }}
        &copy;
        {{ Config::get('app.copyright.name') }}
        -
        v{{ Config::get('app.version') }}
    </small>
</div>

