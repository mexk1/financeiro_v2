import { useNavigate } from "react-router-dom"
import PAGES from "../../constants/PAGES"
import useAccountContext from "./useAccountContext"

const useShouldHaveAccountSelected = () => {

  const { account } = useAccountContext()
  const navigate = useNavigate()

  return account ?? navigate( PAGES.accountsSelect.path )
}
export default useShouldHaveAccountSelected