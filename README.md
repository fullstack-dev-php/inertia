:class="isActiveRoute(menu.active) ? 'active' : ''"
const isActiveRoute=(menuActive)=>{
        return route().current() === menuActive || route().current().startsWith(menuActive + '.');
    }
