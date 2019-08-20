# Customizing the admin styles

```
$admin-bg: rgba(225,128,92,0.9);
$admin-fg: #FFFFFF;
$admin-secondary-bg: rgba(190,98,64,0.9);
$admin-secondary-fg: rgba(255,255,255,0.7);
$admin-highlight-bg: rgba(100,176,169,1);
$admin-highlight-fg: #ffffff;

$admin-ghost-btn: #fff;
$admin-btn-danger-bg: #cc1f1a;
$admin-btn-danger-fg: #fff;

.dvs-btn.dvs-btn-primary {
    background-color: $admin-highlight-bg;
    color: $admin-highlight-fg;
    -webkit-transition: all .5s;
    transition: all .5s
}

.dvs-btn.dvs-btn-primary:hover {
    opacity: .75
}

.dvs-btn.dvs-btn-secondary {
    background-color: $admin-secondary-bg;
    color: $admin-secondary-fg;
    -webkit-transition: all .5s;
    transition: all .5s
}

.dvs-btn.dvs-btn-secondary:hover {
    opacity: .75
}

.dvs-btn.dvs-btn-ghost {
    background-color: transparent;
    border-width: 2px;
    border-color: $admin-ghost-btn
}

.dvs-btn.dvs-btn-danger {
    background-color: $admin-btn-danger-bg;
    color: $admin-btn-danger-fg;
}

.dvs-btn.dvs-btn-danger:hover {
    background-color: $admin-btn-danger-bg;
    color: $admin-btn-danger-fg;
}


.dvs-bg-admin-bg {
    background-color: $admin-bg;
}

.dvs-bg-admin-fg {
    background-color: #fff
}

.dvs-bg-admin-secondary-bg {
    background-color: $admin-secondary-bg
}

.dvs-bg-admin-secondary-fg {
    background-color: $admin-secondary-fg
}

.dvs-bg-admin-highlight-bg {
    background-color: $admin-highlight-bg;
}

.dvs-bg-admin-highlight-fg {
    background-color: $admin-highlight-fg
}

.hover\:dvs-bg-admin-bg:hover {
    background-color: $admin-bg;
}

.hover\:dvs-bg-admin-fg:hover {
    background-color: $admin-fg
}

.hover\:dvs-bg-admin-secondary-bg:hover {
    background-color: $admin-secondary-bg
}

.hover\:dvs-bg-admin-secondary-fg:hover {
    background-color: $admin-secondary-fg
}

.hover\:dvs-bg-admin-highlight-bg:hover {
    background-color: $admin-secondary-bg;
}

.hover\:dvs-bg-admin-highlight-fg:hover {
    background-color: $admin-highlight-fg
}


.dvs-border-admin-bg {
    border-color: $admin-bg;
}

.dvs-border-admin-fg {
    border-color: $admin-fg
}

.dvs-border-admin-secondary-bg {
    border-color: $admin-secondary-bg
}

.dvs-border-admin-secondary-fg {
    border-color: $admin-secondary-fg
}

.dvs-border-admin-highlight-bg {
    border-color: $admin-secondary-bg;
}

.dvs-border-admin-highlight-fg {
    border-color: $admin-highlight-fg
}


.hover\:dvs-border-admin-bg:hover {
    border-color: $admin-bg;
}

.hover\:dvs-border-admin-fg:hover {
    border-color: $admin-fg;
}

.hover\:dvs-border-admin-secondary-bg:hover {
    border-color: $admin-secondary-bg
}

.hover\:dvs-border-admin-secondary-fg:hover {
    border-color: $admin-secondary-fg
}

.hover\:dvs-border-admin-highlight-bg:hover {
    border-color: $admin-secondary-bg;
}

.hover\:dvs-border-admin-highlight-fg:hover {
    border-color: $admin-highlight-fg;
}


.dvs-text-admin-bg {
    color: $admin-bg;
}

.dvs-text-admin-fg {
    color: $admin-fg;
}

.dvs-text-admin-secondary-bg {
    color: $admin-secondary-bg
}

.dvs-text-admin-secondary-fg {
    color: $admin-secondary-fg
}

.dvs-text-admin-highlight-bg {
    color: $admin-secondary-bg;
}

.dvs-text-admin-highlight-fg {
    color: $admin-highlight-fg;
}

.hover\:dvs-text-admin-bg:hover {
    color: $admin-bg;
}

.hover\:dvs-text-admin-fg:hover {
    color: $admin-fg;
}

.hover\:dvs-text-admin-secondary-bg:hover {
    color: $admin-secondary-bg
}

.hover\:dvs-text-admin-secondary-fg:hover {
    color: $admin-secondary-fg
}

.hover\:dvs-text-admin-highlight-bg:hover {
    color: $admin-secondary-bg;
}

.hover\:dvs-text-admin-highlight-fg:hover {
    color: $admin-highlight-fg;
}
```