import React, { Dispatch, SetStateAction } from "react"
import { User } from "../../types/User"


interface UserContextProps {
  state?: User,
  setState: Dispatch<SetStateAction<User | undefined> | User | undefined >
}

const INITIAL_PROPS:UserContextProps = {
  state: undefined,
  setState: () => undefined 
}
const UserContext = React.createContext<UserContextProps>( INITIAL_PROPS )


export default UserContext