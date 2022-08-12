import { useContext } from "react"
import UserContext from "."

const useUserContext = () => {

  const { state, setState } = useContext( UserContext )

  return {
    setUser: setState,
    user: state,
  }
}

export default useUserContext