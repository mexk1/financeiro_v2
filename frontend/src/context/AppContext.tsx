import { PropsWithChildren } from "react"
import AccountContextProvider from "./AccountContext/AccountContextProvider"
import UserContextProvider from "./UserContext/UserContextProvider"

const AppContext = ( {children}:Props ) => {

  return (
    <UserContextProvider>
      <AccountContextProvider>
        { children }
      </AccountContextProvider>
    </UserContextProvider>
  )
}
interface Props extends PropsWithChildren<any>{}

export default AppContext