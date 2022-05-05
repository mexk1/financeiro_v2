import { useContext } from "react"
import UserContext from "../../../context/UserContext"
import { User } from "../../../types/User"

const useUser = ():User | undefined => {
  const { state: user } = useContext( UserContext )
  return user
}


export default useUser