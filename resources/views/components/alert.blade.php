@props(['type' => 'info'])

@php
    $alertId = 'alert_' . uniqid(); 
@endphp

<div 
    id="{{ $alertId }}"
    class="alert alert-{{ $type }} transition-opacity duration-500 ease-in-out"
    role="alert"
>
    <strong>Alert:</strong> {{ $slot }}
</div>

<script>
    setTimeout(() => {
        const alert = document.getElementById('{{ $alertId }}');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }
    }, 2000);
</script>
