@extends('layout.app')

@section('head')

@endsection

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">{{ $header_title }} - {{ $student->name }} {{ $student->last_name }}</h4>
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
    .fc-list-event {
        background-color: #3788d8 !important;
        color: #fff !important;
        border-radius: 6px;
        padding: 4px 8px;
        margin-bottom: 4px;
        text-shadow: 0 0 2px rgba(0, 0, 0, 0.3);
        white-space: normal !important; /* agar teks wrap */
        overflow-wrap: break-word;    /* agar teks wrap */
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
        events: "{{ route('parent.student.calendar.events', $student->id) }}",
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: true
        },
        height: "auto",

        eventDidMount: function(info) {
            if (info.view.type === "dayGridMonth") {
                info.el.style.backgroundColor = info.event.backgroundColor;
                info.el.style.color = info.event.textColor;
                info.el.style.borderRadius = "6px";
                info.el.style.padding = "2px 4px";
            }
            if (info.view.type === "listWeek") {
                info.el.style.backgroundColor = info.event.backgroundColor;
                info.el.style.color = info.event.textColor;
                info.el.style.borderRadius = "6px";
                info.el.style.padding = "4px 8px";
                info.el.style.marginBottom = "4px";
                info.el.style.textShadow = "0 0 2px rgba(0, 0, 0, 0.3)";
                info.el.style.whiteSpace = "normal"; // agar teks wrap di list view
                info.el.style.overflowWrap = "break-word";
            }
        }
    });

    calendar.render();
});
</script>
@endsection
