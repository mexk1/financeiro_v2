import {  PropsWithChildren, useState } from "react"
import AccountContext from "."
import { Account } from "../../types/Account"

const AccountContextProvider: React.FC<PropsWithChildren<any>> = ( { children } ) => {
  
  const [ state, setState ] = useState<Account>()
 
  const props = {
    value: {
      state,
      setState
    },
    children
  }

  return <AccountContext.Provider  { ...props } />
}

export default AccountContextProvider