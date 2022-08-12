import { useCallback, useEffect, useState } from "react"
import api from "../services/api"

const usePagination = <T>( url:string, reversed:boolean = false ) => {

  const [ page, setPage ] = useState<number>(1)
  const [ loading, setLoading ] = useState<boolean>( false )
  const [ end, setEnd ] = useState( false )
  const [ total, setTotal ] = useState<number>( 0 )
  const [ list, setList ] = useState<T[]>( [] )

  const load = useCallback( async () => {
    setLoading( true )
    await api.get( url ).then( res => {
      const body = res.data
      setTotal( body.total )
      if( body.data.lenght === 0 ){
        setEnd( true )
        return 
      }
      if( reversed ){
        return setList( prev => [ ...body.data, ...prev ] )
      }
      setList( prev => [ ...prev, ...body.data ] )
      
    }).catch( console.log )
    setLoading( false )
  }, [ page, reversed ] )

  const reset = () => {
    setPage( 1 )
  }

  const loadMore = () => {
    if( end || loading ) return 
    setPage( page => page + 1 )
  }

  useEffect( () => {
    load()
  }, [ load ] )

  return {
    page,
    loading,
    loadMore,
    total, 
    list,
    reset
  }
}

export default usePagination 