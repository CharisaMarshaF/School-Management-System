@extends('layout.app')

@section('head')

@endsection

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">{{ $header_title }}</h4>
    <div id="calendar"></div>
</div>
<style>
    #calendar {
        max-width: 100%;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .fc .fc-toolbar-title {
        font-size: 1.25rem;
    }

    /* Styling for calendar events */
    .fc-event {
        color: #fff !important;
        padding: 2px 6px;
        border-radius: 6px;
        font-size: 0.875rem;
        text-shadow: 0 0 2px rgba(0, 0, 0, 0.3);
    }

    .fc-daygrid-event {
        white-space: normal !important;
    }

    /* Styling khusus untuk event di list view supaya ada background */
    .fc-list-event {
        background-color: #3788d8 !important; /* warna biru */
        color: #fff !important;
        border-radius: 6px;
        padding: 4px 8px;
        margin-bottom: 4px;
        text-shadow: 0 0 2px rgba(0, 0, 0, 0.3);
    }

    /* ======= TAMBAHAN untuk timeGridWeek supaya teks wrap ======= */
    .fc-timegrid-event .fc-event-title,
    .fc-timegrid-event .fc-event-time {
        white-space: normal !important;
        overflow: visible !important;
        text-overflow: clip !important;
    }

    .fc-timegrid-event {
        height: auto !important;
        min-height: 24px;
        padding: 2px 6px;
        line-height: 1.2em;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
    }

    .fc-timegrid-event .fc-event-main {
        white-space: normal !important;
    }

    .fc-timegrid-event .fc-event-main-frame {
        overflow: visible !important;
    }
</style>
@endsection

@section('script')
<script src="{{ url('public/assets/fullcalendar/index.global.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: "{{ route('student.calendar.events') }}",
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: true
        },
        height: "auto",

        eventDidMount: function(info) {
            // Styling event di month view
            if (info.view.type === "dayGridMonth") {
                info.el.style.backgroundColor = info.event.backgroundColor;
                info.el.style.color = info.event.textColor;
                info.el.style.borderRadius = "6px";
                info.el.style.padding = "2px 4px";
            }

            // Styling event di listWeek view
            if (info.view.type === "listWeek") {
                // Biasanya FullCalendar sudah pakai class .fc-list-event, styling ada di CSS
                // Jika ingin override atau tambahan styling, bisa di sini juga
                info.el.style.backgroundColor = info.event.backgroundColor;
                info.el.style.color = info.event.textColor;
                info.el.style.borderRadius = "6px";
                info.el.style.padding = "4px 8px";
                info.el.style.marginBottom = "4px";
                info.el.style.textShadow = "0 0 2px rgba(0, 0, 0, 0.3)";
            }
        }
    });

    calendar.render();
});
</script>
@endsection
