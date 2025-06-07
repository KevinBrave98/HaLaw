@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="https://drive.usercontent.google.com/download?id=1aqqrT0iyc80lbkg_Dpt-JXungiqnji_S" class="logo" alt="HaLaw logo">
@endif
</a>
</td>
</tr>