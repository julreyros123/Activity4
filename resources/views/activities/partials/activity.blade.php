<div class="task-banner" id="activity-{{ $activity->id }}" hx-target="this" hx-swap="outerHTML">
    <i class="fas fa-tasks task-icon fa-lg"></i>
    <div class="task-details">
        <h5 class="mb-1">{{ $activity->title }}</h5>
        <small>{{ $activity->date }} at {{ $activity->time }}</small>
        <p class="mb-0">{{ $activity->description }}</p>
    </div>
    <div class="task-actions">
        <button hx-get="/activities/{{ $activity->id }}/edit" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-edit"></i>
        </button>
        <button hx-delete="/activities/{{ $activity->id }}" hx-confirm="Are you sure?" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-trash"></i>
        </button>
    </div>
</div>