import { useContext } from "react"
import AccountContext from "."

const useAccountContext = () => {

  const { state, setState } = useContext( AccountContext )

  return {
    setAccount: setState,
    account: state,
  }
}

export default useAccountContext