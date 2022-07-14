import { useCallback, useEffect, useState } from "react"
import DefaultLoader from "../../components/DefaultLoader"
import AccountCardComponent from "../../Domains/Accounts/AccountCardComponent"
import AccountForm from "../../Domains/Accounts/AccountForm"
import LoggedTemplate from "../../Domains/User/LoggedTemplate"
import useModal from "../../hooks/useModal"
import useApi from "../../services/api/hooks/useApi"
import { Account } from "../../types/Account"

const Accounts = () => {

  const api = useApi()

  const [ selectedAccount, setSelectedAccount ] = useState<Account>()

  const { Component: Modal, open, close } = useModal()

  const [ loading, setLoading ] = useState( false )
  const [ accounts, setAccounts ] = useState<Account[]>( [] )

  const load = useCallback( async () => {
    setAccounts([])
    setLoading( true )
    await api.get('accounts')
      .then( res => res.data )
      .then( setAccounts )
      .catch( console.log )
    setLoading( false )
  }, [ api ] )

  const handleUpdate = useCallback( () => {
    setSelectedAccount( undefined )
    close()
    load()
  }, [ load, close ] )

  const selectForUpdate = ( a:Account ) => {
    setSelectedAccount( undefined )
    setTimeout( () => setSelectedAccount( a ), 100 )
  }

  useEffect( () => {
    if( selectedAccount ) open()
  }, [ selectedAccount, open ] )

  useEffect( () => {
    load()
  }, [ load ] )

  useEffect( () => {
    console.log( `render` )
  }, [] )

  return(
    <LoggedTemplate title="Accounts">
      <div className="flex flex-col h-full justify-start items-center gap-4 p-8 w-full" >
        {
          loading && 
          <div className="w-full h-full flex items-center">
            <DefaultLoader />
          </div>
        }
        { 
          accounts.map( account => (
            <AccountCardComponent key={ account.id } account={ account } onClick={ selectForUpdate } />
          ))
        }
        <div >
          <button 
            onClick={ open }
          >Adicionar nova </button>
        </div>
      </div>
      <Modal 
        children={ <AccountForm onSuccess={ handleUpdate }  account={ selectedAccount } /> } 
      />
    </LoggedTemplate>
  )
  
}

export default Accounts