import { FormEvent, useCallback, useState } from "react"
import DefaultForm from "../../components/DefaultForm"
import DefaultInput from "../../components/DefaultInput"
import DefaultInputLabel from "../../components/DefaultInputLabel"
import useShouldHaveAccountSelected from "../../context/AccountContext/useShouldHaveAccountSelected"
import useApi from "../../services/api/hooks/useApi"
import { BankAccount } from "../../types/BankAccount"


interface Props { 
  bankAccount?: BankAccount,
  onSuccess?: ( a: BankAccount ) => void 
}
const BankAccountForm = ( { bankAccount, onSuccess }:Props ) => {

  const [ loading, setLoading ] = useState( false )

  const account = useShouldHaveAccountSelected()

  const api = useApi( )

  const update = async ( data: Object, bankAccount: BankAccount ) => {
    await api.patch<BankAccount>(`/bank-accounts/${bankAccount.id}`, data ).then( res => {
      onSuccess && onSuccess( res.data )
    }).catch( console.log )
  }

  const create = async ( data: Object ) => {
    account && await api.post<BankAccount>(`accounts/${account.id}/bank-accounts`, data ).then( res => {
      onSuccess && onSuccess( res.data )
    }).catch( console.log )
  }

  const handleSubmit = useCallback( async ( e:FormEvent<HTMLFormElement> ) => {
    e.preventDefault()
    setLoading( true )
    const data = new FormData( e.currentTarget )
    if( bankAccount ) update( Object.fromEntries( data ), bankAccount )
    else create( data ) 
    setLoading( false )
  }, [ onSuccess, bankAccount ] )

  return ( 
    <div className="p-4 w-full min-w-[350px] text-black">
      <DefaultForm onSubmit={ handleSubmit } loading={ loading } >
        <DefaultInputLabel label="Nome da Conta Bancária">
          <DefaultInput name="name" defaultValue={ bankAccount?.name } />
        </DefaultInputLabel>
      </DefaultForm>
    </div>
  )
}

export default BankAccountForm