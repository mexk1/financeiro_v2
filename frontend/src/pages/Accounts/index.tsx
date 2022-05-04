import { useCallback, useEffect, useState } from "react"
import AccountCardComponent from "../../Domains/Accounts/AccountCardComponent"
import LoggedTemplate from "../../Domains/User/LoggedTemplate"
import { Account } from "../../types/Account"

const Accounts = () => {

  const [ accounts, setAccounts ] = useState<Account[]>( [] )

  const load = useCallback( async () => {
    // const accounts = await fetch( '' )
    //   .then( res => res.json() )
    //   .catch( console.log )

    const accounts:Account[] = [
      {
        id: 1,
        name: 'Conta 1'
      },
      {
        id: 2,
        name: 'Conta 2'
      },
      {
        id: 3,
        name: 'Conta 3'
      }
    ]
    setAccounts( accounts ?? [] )
  }, [] )

  useEffect( () => {
    load()
  }, [ load ] )

  return(
    <LoggedTemplate>
      <div className="flex flex-col h-full justify-start items-center gap-4 p-8 w-full" >
        { 
          accounts.map( account => (
            <AccountCardComponent key={ account.id } account={ account } />
          ))
        }
      </div>
    </LoggedTemplate>
  )
  
}

export default Accounts