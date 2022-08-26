import {
  Routes as Wrapper, Route
} from "react-router-dom"
import PAGES from "../constants/PAGES"
import LoggedTemplate from "../Domains/User/LoggedTemplate"
import Accounts from "../pages/Accounts"
import AccountSelect from "../pages/Accounts/AccountSelect"
import Home from "../pages/Home"
import Login from "../pages/Login"
import Logout from "../pages/Logout"
import Received from "../pages/Received"
import Spends from "../pages/Spends"

const Routes = () => {

  return (
    <>
      <Wrapper>
        <Route path={PAGES.login.path} element={<Login />} />
      </Wrapper>
      <LoggedTemplate >
        <Wrapper>
          <Route path={PAGES.home.path} element={<Home />} />
          <Route path={PAGES.accounts.path} element={<Accounts />} />
          <Route path={PAGES.accountsSelect.path} element={<AccountSelect />} />
          <Route path={PAGES.spends.path} element={<Spends />} />
          <Route path={PAGES.received.path} element={<Received />} />
          <Route path={PAGES.logout.path} element={<Logout />} />
        </Wrapper>
      </LoggedTemplate>
    </>

  )

}

export default Routes