# Groups

On this page you can edit existing groups. A group only has one field: **the name**. Visit the [user's edit page](/admin/users/1/edit) to attach this group to a specific user. It is not generally a good idea to change the group name because the developer may be referencing it inside of this application. Any name change made here could break things in other parts of the application. Rather than change this group name it is suggested to create a new group. Change at your own risk.

### Name

Name the groups for whatever makes sense inside your application. Developers can use the group name to ensure the current logged in user is a member.

```
@if (DeviseUser::isInGroup("@livespan([name=name], group1)"))
	// allow some action or show something
	// this current user is allowed to execute this code
@endif
```

If the developer would like to know when a user is in at least one group, she can pass multiple arguments like so...

```
@if (DeviseUser::isInGroup("group1", "group2"))
	// this current user is in group1 or group2 or both...
@endif
```

There are other methods the developer can use such as `isNotInGroup`, `isInGroups`, `isNotInGroups`

```
@if (DeviseUser::isInGroups("group1", "group2"))
	// the current user is in **both** group1 and group2
@endif
```

Several other rules for checking permissions and groups can be found in the [RuleList class](https://github.com/devisephp/cms/blob/master/src/Devise/Users/Permissions/RuleList.php#L114).