import { FormEvent, useCallback, useState } from "react"
import DefaultForm from "../../components/DefaultForm"
import DefaultInput from "../../components/DefaultInput"
import DefaultInputLabel from "../../components/DefaultInputLabel"
import useApi from "../../services/api/hooks/useApi"
import { Account } from "../../types/Account"


interface Props { 
  account?: Account,
  onSuccess?: ( a: Account ) => void 
}
const AccountForm = ( { account, onSuccess }:Props ) => {

  const [ loading, setLoading ] = useState( false )

  const api = useApi( )

  const handleSubmit = useCallback( async ( e:FormEvent<HTMLFormElement> ) => {
    e.preventDefault()
    setLoading( true )
    const data = new FormData( e.currentTarget )
    await api.post<Account>(`/accounts`, data ).then( res => {
      console.log( res.data )
      onSuccess && onSuccess( res.data )
    }).catch( console.log )
    setLoading( false )
  }, [ onSuccess ] )

  return ( 
    <div className="p-4 w-full min-w-[350px]">
      <DefaultForm onSubmit={ handleSubmit } >
        <DefaultInputLabel label="Nome da Conta">
          <DefaultInput name="name" />
        </DefaultInputLabel>
      </DefaultForm>
    </div>
  )
}

export default AccountForm