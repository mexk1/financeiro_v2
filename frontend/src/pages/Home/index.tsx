import { useNavigate } from "react-router-dom"
import PAGES from "../../constants/PAGES"
import useShouldHaveAccountSelected from "../../context/AccountContext/useShouldHaveAccountSelected"
import LoggedTemplate from "../../Domains/User/LoggedTemplate"

const Home = () => {
  const account = useShouldHaveAccountSelected()
  const navigate = useNavigate() 

  return(
    <LoggedTemplate 
      title="Home" 
      subTitle={{
        text: account?.name,
        action: () => navigate(PAGES.accountsSelect.path)
      }} 
    >
      Home
    </LoggedTemplate>
  )
}

export default Home