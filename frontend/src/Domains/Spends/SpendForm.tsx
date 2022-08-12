
import { FormEvent, useCallback, useState } from "react"
import DefaultForm from "../../components/DefaultForm"
import DefaultInput from "../../components/DefaultInput"
import DefaultInputLabel from "../../components/DefaultInputLabel"
import useShouldHaveAccountSelected from "../../context/AccountContext/useShouldHaveAccountSelected"
import useApi from "../../services/api/hooks/useApi"
import { Spend } from "../../types/Spend"


interface Props { 
  spend?: Spend,
  onSuccess?: ( a: Spend ) => void 
}
const SpendForm = ( { onSuccess, spend }:Props ) => {

  const account = useShouldHaveAccountSelected()

  const [ loading, setLoading ] = useState( false )

  const api = useApi( )

  const update = async ( data: Object, spend: Spend ) => {
    await api.patch<Spend>(`/accounts/${account?.id}/spends/${spend.id}`, data ).then( res => {
      onSuccess && onSuccess( res.data )
    }).catch( console.log )
  }

  const create = async ( data: Object ) => {
    await api.post<Spend>(`/accounts/${account?.id}/spends`, data ).then( res => {
      onSuccess && onSuccess( res.data )
    }).catch( console.log )
  }

  const handleSubmit = useCallback( async ( e:FormEvent<HTMLFormElement> ) => {
    e.preventDefault()
    setLoading( true )
    const data = new FormData( e.currentTarget )
    if( spend ) update( Object.fromEntries( data ), spend )
    else create( data ) 
    setLoading( false )
  }, [ onSuccess, spend ] )

  return ( 
    <div className="p-4 w-full min-w-[350px] text-black">
      <DefaultForm onSubmit={ handleSubmit } loading={ loading } >
        <DefaultInputLabel label="Descrição">
          <DefaultInput name="description" defaultValue={ spend?.description } />
        </DefaultInputLabel>
        <DefaultInputLabel label="Value">
          <DefaultInput name="value" type="numeric" defaultValue={ spend?.value } />
        </DefaultInputLabel>
      </DefaultForm>
    </div>
  )
}

export default SpendForm
