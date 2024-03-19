export default {
    methods: {
      $can(permissionName) {
        const permissions = JSON.parse(
          localStorage.getItem("permissions")
        );
        //   const permissions = [store.getters.getPermissions];
        if (permissions) return permissions.indexOf(permissionName) !== -1;
      },
    },
  };