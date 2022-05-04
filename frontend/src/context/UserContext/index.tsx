import React, { Dispatch, SetStateAction } from "react"
import { User } from "../../types/User"


interface UserContextProps {
  state?: User,
  setState?: Dispatch<SetStateAction<User | undefined>>
}
const UserContext = React.createContext<UserContextProps>( {} )


export default UserContext