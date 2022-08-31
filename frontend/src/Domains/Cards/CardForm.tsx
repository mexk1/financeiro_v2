import { FormEvent, useCallback, useEffect, useState } from "react"
import DefaultForm from "../../components/DefaultForm"
import DefaultInput from "../../components/DefaultInput"
import DefaultInputLabel from "../../components/DefaultInputLabel"
import DefaultSelect from "../../components/DefaultSelect"
import useShouldHaveAccountSelected from "../../context/AccountContext/useShouldHaveAccountSelected"
import useApi from "../../services/api/hooks/useApi"
import { BankAccount } from "../../types/BankAccount"
import { Card } from "../../types/Card"


interface Props { 
  card?: Card,
  onSuccess?: ( a: Card ) => void 
}
const CardForm = ( { card, onSuccess }:Props ) => {

  const [ loading, setLoading ] = useState( false )
  const [bankAccounts, setBankAccounts] = useState<BankAccount[]>([])

  const account = useShouldHaveAccountSelected()

  const api = useApi( )

  const update = async ( data: Object, card: Card ) => {
    await api.patch<Card>(`/cards/${card.id}`, data ).then( res => {
      onSuccess && onSuccess( res.data )
    }).catch( console.log )
  }

  const create = async ( data: Object ) => {
    account && await api.post<Card>(`accounts/${account.id}/cards`, data ).then( res => {
      onSuccess && onSuccess( res.data )
    }).catch( console.log )
  }

  const handleSubmit = useCallback( async ( e:FormEvent<HTMLFormElement> ) => {
    e.preventDefault()
    setLoading( true )
    const data = new FormData( e.currentTarget )
    if( card ) update( Object.fromEntries( data ), card )
    else create( data ) 
    setLoading( false )
  }, [ onSuccess, card ] )

  useEffect( () => {
    const controller = new AbortController()

    account && api.get(`accounts/${account.id}/bank-accounts`, { signal: controller.signal })
      .then( res => {
        setBankAccounts( res.data )
      })
      .catch( console.log )

    return () => {
      controller.abort()
    }
  }, [ api, account ] )

  return ( 
    <div className="p-4 w-full min-w-[350px] text-black">
      <DefaultForm onSubmit={ handleSubmit } loading={ loading } >
        <DefaultInputLabel label="Conta">
          <DefaultSelect 
            options={ bankAccounts.map( b => ({
              value: b.id,
              label: b.name
            })) }
            name="bank_account" 
          />
        </DefaultInputLabel>
        <DefaultInputLabel label="Nome do Cartão">
          <DefaultInput name="name" defaultValue={ card?.name } />
        </DefaultInputLabel>
        <DefaultInputLabel label="ultimos 4 digitos">
          <DefaultInput name="last_digits" defaultValue={ card?.last_digits } />
        </DefaultInputLabel>
        <DefaultInputLabel label="dia de fechamento da fatura">
          <DefaultInput name="bill_close_day" defaultValue={ card?.bill_close_day } />
        </DefaultInputLabel>
        <DefaultInputLabel label="Tipo">
          <DefaultSelect 
            options={ [
              {
                value: `debit`,
                label: 'Débito'
              },
              {
                value: `credit`,
                label: 'Crédito'
              },
              {
                value: `both`,
                label: 'Ambos'
              },
            ]}
            name="mode" 
          />
        </DefaultInputLabel>
      </DefaultForm>
    </div>
  )
}

export default CardForm