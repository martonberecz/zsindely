@component('mail::message')
# A rendeles reszletei

@component('mail::table')

| Tétel szövege                          | Mennyiseg                               | Anyag egységár (Ft)   | Díj egységre  (Ft)       | Anyag összesen (Ft) | Díj összesen (Ft) |
|:---------------------------------------|----------------------------------------:|:-----------------------|------------------------:|--------------------:|------------------:|
@foreach ($items as $item)
| {{$item['title']}}                     | {{$item['amount']}}{{$item['egyseg']}}  | {{$item['egysegar']}} | {{$item['dijegysegre']}} |{{$item['anyagSum']}}|{{$item['dijSum']}}|
@endforeach
@endcomponent
@component('mail::table')
|                           | Anyag összesen (Ft)                           | Díj összesen (Ft)                         |
|:--------------------------|----------------------------------------------:|:------------------------------------------|
|Mindösszesen nettó         | {{$total['anyagSum']}}                        |  {{$total['dijSum']}}                     |
|Mindösszesen bruttó (+20%):|{{($total['anyagSum']*0.2)+$total['anyagSum']}}|  {{$total['dijSum']*0.2+$total['dijSum']}}|
                           
@endcomponent

{{-- @component('mail::button', ['url' => ''])
Button Text --}}
{{-- @endcomponent --}}



Koszonjuk,<br>
{{ config('app.name') }}
@endcomponent
