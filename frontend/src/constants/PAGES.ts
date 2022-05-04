import Home from "../pages/Home"
import Login from "../pages/Login"
import { Page } from "../types/page"

const PAGES = {

  login: { 
    path: '/login',
    name: 'Login',
  } as Page,

  home: { 
    path: '/',
    name: 'Home',
  } as Page

}

export default PAGES