<div wire:ignore>
    <div id="calendar" style="height:600px;"></div>
</div>

<script>
    document.addEventListener('livewire:navigated', () => {
        initCalendar()
    })

    document.addEventListener('DOMContentLoaded', () => {
        initCalendar()
    })
</script>
