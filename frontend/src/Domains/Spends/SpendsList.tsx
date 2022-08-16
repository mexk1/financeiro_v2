import { Spend } from "../../types/Spend"

interface Props {
  list: Spend[],
  onClickItem?: ( s:Spend ) => void
}

interface ItemProps {
  spend: Spend,
  onClickItem?: ( s:Spend ) => void
}
const ListItem = ( { spend, onClickItem }:ItemProps ) => {
  const handleClick = () => {
    onClickItem && onClickItem( spend )
  }
  const dateFormat = ( input:string ) => {
    const date = new Date( input )
    const day = date.getDate()
    const month = date.getMonth()
    const year = date.getFullYear()

    return `${day}/${month}/${year}`
  }
  return (
    <div 
      className="flex justify-between align-center rounded bg-gray-100 p-2" 
      onClick={ handleClick } 
    >
      <div className="text-xl">
        <span>{ spend.description }</span>
        <div className="flex gap-2 text-xs text-gray-500">
          <div>
            <span>#</span>
            {spend.id}
          </div>
          <span>{dateFormat(spend.created_at)}</span>
        </div>
      </div>
      <div className="flex items-center h-full text-xl flex-1 justify-end text-red-400">
        R$
        <span>
          { spend.value }
        </span>
      </div>
    </div>
  )
}

const SpendsList = ( { list, onClickItem }:Props ) => {
  return (
   <div className="w-full gap-4 flex flex-col rounded text-black">
      {
        list.map( spend => ( 
          <ListItem 
            key={ spend.id } 
            spend={ spend }
            onClickItem={ onClickItem }
          />
        ))
      }
    </div>
  )
}

export default SpendsList