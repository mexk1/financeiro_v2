import { useNavigate } from "react-router-dom"
import PAGES from "../../constants/PAGES"
import useShouldHaveAccountSelected from "../../context/AccountContext/useShouldHaveAccountSelected"
import LoggedTemplate from "../../Domains/User/LoggedTemplate"

const Received = () => {

  const account = useShouldHaveAccountSelected()
  const navigate = useNavigate() 

  return(
    <LoggedTemplate 
      title="Received" 
      subTitle={{
        text: account?.name,
        action: () => navigate(PAGES.accountsSelect.path)
      }} 
    >
      Received
    </LoggedTemplate>
  )
  
}

export default Received