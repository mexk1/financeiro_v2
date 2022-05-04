import { 
  Routes as Wrapper, Route 
} from "react-router-dom"
import PAGES from "../constants/PAGES"
import Accounts from "../pages/Accounts"
import Home from "../pages/Home"
import Login from "../pages/Login"

const Routes = () => {

  return (
    <Wrapper>
      <Route path="/accounts" element={ <Accounts /> }/>
      <Route path={ PAGES.login.path } element={<Login /> } />
      <Route path={ PAGES.home.path } element={<Home />} />
    </Wrapper>
  )

}

export default Routes