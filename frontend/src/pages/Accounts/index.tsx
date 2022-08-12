import { useCallback, useEffect, useState } from "react"
import DefaultLoader from "../../components/DefaultLoader"
import Modal from "../../components/Modal"
import AccountCardComponent from "../../Domains/Accounts/AccountCardComponent"
import AccountForm from "../../Domains/Accounts/AccountForm"
import LoggedTemplate from "../../Domains/User/LoggedTemplate"
import useModalControls from "../../hooks/useModalControls"
import useApi from "../../services/api/hooks/useApi"
import { Account } from "../../types/Account"

const Accounts = () => {

  const api = useApi()

  const [ selectedAccount, setSelectedAccount ] = useState<Account>()

  const [ loading, setLoading ] = useState( false )
  const [ accounts, setAccounts ] = useState<Account[]>( [] )

  const { open, close, isOpen } = useModalControls()

  const load = useCallback( async () => {
    setAccounts([])
    setLoading( true )
    await api.get('accounts')
      .then( res => res.data )
      .then( setAccounts )
      .catch( console.log )
    setLoading( false )
  }, [ api ] )

  const handleUpdate = () => {
    setSelectedAccount( undefined )
    close()
    load()
  }

  const selectForUpdate = ( a:Account ) => {
    setSelectedAccount( undefined )
    close()
    setTimeout( () => {
      open()
      setSelectedAccount( a )
    }, 100 )
  }

  const Form = useCallback( () => (
    <AccountForm 
      onSuccess={ handleUpdate }  
      account={ selectedAccount } 
    /> 
  ), [ selectedAccount ] )

  useEffect( () => {
    load()
  }, [ load ] )

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
            <AccountCardComponent 
              key={ account.id } 
              account={ account } 
              onClick={ selectForUpdate } 
            />
          ))
        }
        <div className="text-black">
          <Modal
            trigger={ props => ( <>
              {
                !loading && 
                  <button
                    { ...props } 
                    className={ "text-white" + ( props?.className ?? '' )} 
                    onClick={ e => {
                        setSelectedAccount( undefined )
                        props?.onClick && props.onClick( e )
                      }
                    }
                  >
                    Adicionar nova
                  </button>
              }
            </> 
            ) }
            isOpen={ isOpen }
            onOpen={ open }
            onClose={ close }
            children={ <Form /> }
          />
        </div>
      </div>
      
    </LoggedTemplate>
  )
  
}

export default Accounts