```
@if(DeviseUser::checkRule('isLoggedIn'))
    @live-code("permission-name|canAccessAdmin")
@endif
```