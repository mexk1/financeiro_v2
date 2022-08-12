import { Account } from "../../types/Account"

const AccountCardComponent = ( { account, onClick, highlight }:Props ) => {

  const handleClick = () => {
    onClick && onClick( account )
  }

  const classes = [
    'bg-white rounded-md shadow-md',
    'shadow-indigo-400 text-black',
    'w-full mx-4 flex items-center justify-center',
    ( highlight ? 'shadow-green-400' : '' )
  ]

  return (
    <div className={ classes.join(' ') } onClick={ handleClick } >
      { account.name }
    </div>
  )
}

interface Props { 
  account: Account,
  onClick?: ( a:Account ) => void,
  highlight?: boolean
}

export default AccountCardComponent