
import { AxiosError, AxiosResponse } from "axios"
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

interface InvalidResponse {
  errors: {}
}
const SpendForm = ( { onSuccess, spend }:Props ) => {

  const account = useShouldHaveAccountSelected()

  const [ loading, setLoading ] = useState( false )

  const api = useApi( )

  const handleValidationError = ( error:AxiosError<InvalidResponse,AxiosResponse>, form:HTMLFormElement ) => {
    Object.entries( error.response?.data?.errors ?? {} ).forEach( ( [field, errors] ) => {
      const input = form.querySelector(`[name="${field}"]`)
      const message = document.createElement('div');
      ( errors as string[] ).map( (e:string) => {
        message.innerHTML = message.innerHTML + `<br>` + e 
      } )
      input?.parentNode?.appendChild( message )
      setTimeout( () => {
        input?.parentNode?.removeChild( message )
      }, 3000 )
    })
  }

  const update = async ( data: Object, spend: Spend, form:HTMLFormElement ) => {
    return await api.patch<Spend>(`/accounts/${account?.id}/spends/${spend.id}`, data ).then( res => {
      onSuccess && onSuccess( res.data )
    }).catch( err => handleValidationError( err, form ) )
  }

  const create = async ( data: Object, form:HTMLFormElement ) => {
    return await api.post<Spend>(`/accounts/${account?.id}/spends`, data ).then( res => {
      onSuccess && onSuccess( res.data )
    }).catch( err => handleValidationError( err, form ) )
  }

  const handleSubmit = useCallback( async ( e:FormEvent<HTMLFormElement> ) => {
    e.preventDefault()
    setLoading( true )
    const data = new FormData( e.currentTarget )

    if( spend ) await update( Object.fromEntries( data ), spend, e.currentTarget )
    else await create( data, e.currentTarget ) 
    
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
