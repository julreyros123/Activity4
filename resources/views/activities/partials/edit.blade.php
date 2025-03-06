<div class="task-banner" id="activity-{{ $activity->id }}" hx-target="this" hx-swap="outerHTML">
    <i class="fas fa-tasks task-icon fa-lg"></i>
    <form hx-put="/activities/{{ $activity->id }}" class="d-flex w-100 align-items-center">
        <div class="task-details">
            <input type="text" name="title" value="{{ $activity->title }}" required class="form-control mb-1">
            <div class="d-flex gap-2">
                <input type="date" name="date" value="{{ $activity->date }}" required class="form-control">
                <input type="time" name="time" value="{{ $activity->time }}" required class="form-control">
            </div>
            <input type="text" name="description" value="{{ $activity->description }}" required class="form-control mt-1">
        </div>
        <div class="task-actions">
            <button type="submit" class="btn btn-sm btn-primary">
                <i class="fas fa-save"></i>
            </button>
            <button hx-get="/activities/{{ $activity->id }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </form>
</div>