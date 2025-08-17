<x-mail::message>
# Introduction

YAWA JJJJ {{ $user->name}}

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
