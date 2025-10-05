# Icon Component Usage Examples

## Basic Usage

### Simple Icon
```blade
<x-icon name="dashboard" />
```

### Sized Icon
```blade
<x-icon name="search" size="16" />
<x-icon name="users" size="24" />
```

### Icon with Custom Classes
```blade
<x-icon name="warning" class="text-yellow-500" />
<x-icon name="success" class="text-green-600" />
```

### Icon with Custom Stroke Width
```blade
<x-icon name="edit" stroke="2" />
```

## Navigation Examples

### Navigation Link
```blade
<a href="{{ route('admin.dashboard') }}" class="nav-link">
    <x-icon name="dashboard" class="nav-icon" />
    <span>Dashboard</span>
</a>
```

### Navigation with Active State
```blade
<li class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
    <a href="{{ route('admin.users.index') }}">
        <x-icon name="users" class="nav-icon" />
        <span>Users</span>
    </a>
</li>
```

## Button Examples

### Primary Action Button
```blade
<button type="submit" class="btn btn-primary">
    <x-icon name="save" size="16" class="mr-2" />
    Save Changes
</button>
```

### Icon-only Button
```blade
<button type="button" class="btn-icon" aria-label="Edit item">
    <x-icon name="edit" size="18" />
</button>
```

### Search Button
```blade
<button type="submit" class="btn btn-outline">
    <x-icon name="search" size="16" />
    <span class="ml-2">Search</span>
</button>
```

## Form Examples

### Read-only Field with Lock Icon
```blade
<div class="form-group">
    <label for="name">Name (Read-only)</label>
    <div class="input-group">
        <input type="text" id="name" value="{{ $user->name }}" readonly class="form-control readonly">
        <div class="input-group-append">
            <x-icon name="lock" size="18" class="text-muted" />
        </div>
    </div>
</div>
```

### Field Validation with Status Icons
```blade
<div class="form-group">
    <input type="email" class="form-control @error('email') is-invalid @enderror">
    @error('email')
        <div class="invalid-feedback d-flex align-items-center">
            <x-icon name="error" size="16" class="mr-1 text-danger" />
            {{ $message }}
        </div>
    @enderror
</div>
```

## Status Examples

### Success Message
```blade
<div class="alert alert-success">
    <x-icon name="success" size="20" class="mr-2" />
    Operation completed successfully!
</div>
```

### Warning Alert
```blade
<div class="alert alert-warning">
    <x-icon name="warning" size="20" class="mr-2" />
    Please review the following information.
</div>
```

## Table Examples

### Action Buttons in Table
```blade
<td class="actions">
    <a href="{{ route('admin.users.show', $user) }}" class="btn-sm" title="View">
        <x-icon name="view" size="16" />
    </a>
    <a href="{{ route('admin.users.edit', $user) }}" class="btn-sm" title="Edit">
        <x-icon name="edit" size="16" />
    </a>
    <button onclick="confirmDelete({{ $user->id }})" class="btn-sm text-danger" title="Delete">
        <x-icon name="delete" size="16" />
    </button>
</td>
```

## Modal Examples

### Modal Header with Close Button
```blade
<div class="modal-header">
    <h5 class="modal-title">Add New User</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <x-icon name="close" size="18" />
    </button>
</div>
```

### Modal Footer with Action Buttons
```blade
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">
        <x-icon name="cancel" size="16" class="mr-1" />
        Cancel
    </button>
    <button type="submit" class="btn btn-primary">
        <x-icon name="save" size="16" class="mr-1" />
        Save User
    </button>
</div>
```

## Available Icons

### Navigation Icons
- `dashboard` - Layout grid
- `applications` - Document with lines
- `users` - User group
- `violations` - Warning triangle
- `reports` - Chart pie
- `profile` - User circle
- `logout` - Arrow right from rectangle

### Action Icons
- `search` - Magnifying glass
- `edit` - Pencil square
- `delete` - Trash
- `add` - Plus circle
- `save` - Check mark
- `close` - X mark
- `cancel` - X mark
- `view` - Eye
- `download` - Arrow down tray
- `print` - Printer

### Status Icons
- `lock` - Lock closed
- `success` - Check circle
- `warning` - Exclamation triangle
- `error` - X circle
- `info` - Information circle

## Styling Tips

### CSS Classes for Common Icon Styles
```css
.nav-icon {
    width: 20px;
    height: 20px;
    margin-right: 8px;
}

.btn-icon {
    width: 16px;
    height: 16px;
}

.status-icon {
    width: 18px;
    height: 18px;
    vertical-align: middle;
}

.text-muted {
    color: #6c757d;
}
```

### Responsive Icon Sizing
```css
@media (max-width: 768px) {
    .nav-icon {
        width: 18px;
        height: 18px;
    }
    
    .btn-icon {
        width: 14px;
        height: 14px;
    }
}
```