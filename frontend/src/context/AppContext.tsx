import { PropsWithChildren } from "react"
import UserContextProvider from "./UserContext/UserContextProvider"

const AppContext = ( {children}:Props ) => {

  return (
    <UserContextProvider>
      { children }
    </UserContextProvider>
  )
}
interface Props extends PropsWithChildren<any>{}

export default AppContext