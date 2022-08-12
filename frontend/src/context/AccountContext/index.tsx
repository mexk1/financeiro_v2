import React, { Dispatch, SetStateAction } from "react"
import { Account } from "../../types/Account"


interface AccountContextProps {
  state?: Account,
  setState: Dispatch<SetStateAction<Account | undefined> | Account | undefined >
}

const INITIAL_PROPS:AccountContextProps = {
  state: undefined,
  setState: () => undefined 
}
const AccountContext = React.createContext<AccountContextProps>( INITIAL_PROPS )


export default AccountContext