import { AxiosRequestConfig } from "axios"
import { useCallback, useEffect, useState } from "react"
import api from "../services/api"

export interface PaginationConsumerProps<T>{
  page: number | undefined,
  loading: boolean,
  end: boolean,
  loadMore: () => void,
  total: number,
  list: T[],
  reset: () => void
}

const usePagination = <T>( url:string, reversed:boolean = false ):PaginationConsumerProps<T> => {

  const [ page, setPage ] = useState<number>()
  const [ loading, setLoading ] = useState<boolean>( false )
  const [ end, setEnd ] = useState( false )
  const [ total, setTotal ] = useState<number>( 0 )
  const [ list, setList ] = useState<T[]>( [] )

  const reset = useCallback( async () => {
    setPage( undefined )
    setTimeout( () => {
      setPage( 1 )
    }, 200 )
  }, [ ] )

  const loadMore = () => {
    if( end || loading ) return 
    setPage( page => {
      return ( page ?? 1 ) + 1
    } )
  }

  useEffect( () => {
    const controller = new AbortController()
    const load = async () => {
      if( !page ){
        return
      }
      setLoading( true )
      if( page === 1 ){
        setList( [] )
      }
      const config:AxiosRequestConfig = {
        signal: controller.signal,
        params: { page }
      }
      await api.get( url,  config  ).then( res => {
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
    }
    load()
    return () => {
      controller.abort()
    }
  }, [ page, reversed ] )

  useEffect( () => {
    reset()
  }, [ reset ] )

  return {
    page,
    loading,
    loadMore,
    total, 
    list,
    reset,
    end
  }
}

export default usePagination 