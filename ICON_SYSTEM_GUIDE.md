# Icon System Guide

## Overview
This application uses a modern, consistent icon system based on **Heroicons** - a set of beautiful hand-crafted SVG icons by the makers of Tailwind CSS.

## Icon Standards

### 1. Icon Library
- **Primary Library**: [Heroicons](https://heroicons.com/) - Outline style
- **Format**: Inline SVG
- **Style**: Outline (stroke-based) icons preferred for consistency

### 2. Icon Sizing
- **Navigation Icons**: 20px × 20px
- **Button Icons**: 16px × 18px  
- **Large Feature Icons**: 24px × 24px
- **Small Utility Icons**: 14px × 14px

### 3. Icon Attributes
All icons should include these standard attributes:
```html
<svg xmlns="http://www.w3.org/2000/svg" 
     fill="none" 
     viewBox="0 0 24 24" 
     stroke-width="1.5" 
     stroke="currentColor" 
     style="width: 20px; height: 20px;">
```

### 4. Icon Classes
- `nav-icon` - For main navigation items
- `nav-subicon` - For sub-navigation items  
- `btn-icon` - For button icons
- `action-icon` - For action buttons

## Icon Usage by Category

### Navigation Icons
- **Dashboard**: Layout grid icon
- **Applications**: Document with lines icon
- **Accounts/Users**: User group icon
- **Violations**: Warning triangle icon
- **Reports**: Chart pie icon
- **Profile**: User circle icon
- **Logout**: Arrow right from rectangle icon

### Action Icons
- **Edit**: Pencil square icon
- **Delete**: Trash icon
- **Search**: Magnifying glass icon
- **Add**: Plus circle icon
- **Save**: Check icon
- **Cancel**: X mark icon
- **Close**: X mark icon
- **Download**: Arrow down tray icon
- **Print**: Printer icon
- **View**: Eye icon

### Status Icons
- **Success**: Check circle icon (green)
- **Warning**: Exclamation triangle icon (yellow)
- **Error**: X circle icon (red)
- **Info**: Information circle icon (blue)
- **Lock**: Lock closed icon (for read-only fields)

## Implementation Examples

### Navigation Icon
```html
<svg xmlns="http://www.w3.org/2000/svg" 
     class="nav-icon" 
     fill="none" 
     stroke="currentColor" 
     viewBox="0 0 24 24" 
     stroke-width="1.5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
</svg>
```

### Button Icon
```html
<button class="btn-primary" style="display: flex; align-items: center; gap: 8px;">
  <svg xmlns="http://www.w3.org/2000/svg" 
       fill="none" 
       viewBox="0 0 24 24" 
       stroke-width="1.5" 
       stroke="currentColor" 
       style="width: 16px; height: 16px;">
    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
  </svg>
  Search
</button>
```

### Lock Icon (Read-only fields)
```html
<svg xmlns="http://www.w3.org/2000/svg" 
     fill="none" 
     viewBox="0 0 24 24" 
     stroke-width="1.5" 
     stroke="currentColor" 
     style="height: 20px; width: 20px; color: #6c757d;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
</svg>
```

## CSS Styling

### Icon Colors
- **Default**: `currentColor` (inherits from parent)
- **Primary**: `var(--primary-green)` (#00B050)
- **Secondary**: `#6c757d` (muted gray)
- **Success**: `#10b981` (green)
- **Warning**: `#f59e0b` (amber)
- **Danger**: `#ef4444` (red)

### Responsive Considerations
- Icons scale with their containers
- Use relative units (em/rem) when possible
- Ensure 44px minimum touch targets on mobile
- Consider icon-only buttons on small screens

## Best Practices

### DO:
✅ Use consistent stroke-width (1.5)  
✅ Include proper xmlns attribute  
✅ Use semantic naming for icon purposes  
✅ Maintain consistent sizing within contexts  
✅ Use `currentColor` for automatic theming  
✅ Add appropriate ARIA labels for accessibility  

### DON'T:
❌ Mix different icon styles (outline + solid)  
❌ Use inconsistent sizing within the same view  
❌ Omit xmlns attribute  
❌ Use icons without clear meaning  
❌ Make icons too small for touch interfaces  
❌ Forget accessibility considerations  

## Accessibility

### Screen Readers
- Add `aria-label` for icon-only buttons
- Use `aria-hidden="true"` for decorative icons
- Include text alternatives when necessary

```html
<!-- Good: Icon with text -->
<button>
  <svg aria-hidden="true">...</svg>
  Search
</button>

<!-- Good: Icon-only with label -->
<button aria-label="Close dialog">
  <svg aria-hidden="true">...</svg>
</button>
```

## Future Enhancements
- Create Blade component for common icons
- Implement icon sprite system for better performance
- Add dark mode icon variants
- Create automated icon optimization pipeline

---

**Last Updated**: December 2024  
**Version**: 1.0  
**Maintained By**: Development Team